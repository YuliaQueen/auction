<?php

namespace App\Auth\Entity\User;

use App\Auth\Service\PasswordHasher;
use ArrayObject;
use DateTimeImmutable;
use DomainException;

class User
{
    private Id $id;
    private DateTimeImmutable $date;
    private Email $email;
    private ?Email $newEmail = null;
    private ?string $passwordHash = null;
    private ?Token $joinConfirmToken = null;
    private Status $status;
    private ArrayObject $networks;
    private ?Token $passwordResetToken = null;
    private ?Token $newEmailToken = null;
    private Role $role;

    /**
     * @param Id $id
     * @param DateTimeImmutable $date
     * @param Email $email
     * @param Status $status
     */
    private function __construct(Id $id, DateTimeImmutable $date, Email $email, Status $status)
    {
        $this->id = $id;
        $this->date = $date;
        $this->email = $email;
        $this->status = $status;
        $this->networks = new ArrayObject();
        $this->role = Role::user();
    }

    /**
     * @param Id $id
     * @param DateTimeImmutable $date
     * @param Email $email
     * @param string $passwordHash
     * @param Token $token
     *
     * @return User
     */
    public static function requestJoinByEmail(
        Id $id,
        DateTimeImmutable $date,
        Email $email,
        string $passwordHash,
        Token $token
    ): User {
        $user = new self($id, $date, $email, Status::wait());
        $user->passwordHash = $passwordHash;
        $user->joinConfirmToken = $token;

        return $user;
    }

    /**
     * @param Id $id
     * @param DateTimeImmutable $date
     * @param Email $email
     * @param NetworkIdentity $identity
     *
     * @return User
     */
    public static function joinByNetwork(
        Id $id,
        DateTimeImmutable $date,
        Email $email,
        NetworkIdentity $identity
    ): User {
        $user = new self($id, $date, $email, Status::active());
        $user->networks->append($identity);

        return $user;
    }

    /**
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @return Email
     */
    public function getEmail(): Email
    {
        return $this->email;
    }

    /**
     * @return Email|null
     */
    public function getNewEmail(): ?Email
    {
        return $this->newEmail;
    }

    /**
     * @return Token|null
     */
    public function getNewEmailToken(): ?Token
    {
        return $this->newEmailToken;
    }



    /**
     * @return string
     */
    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    /**
     * @return Status
     */
    public function getStatus(): Status
    {
        return $this->status;
    }

    /**
     * @return array
     */
    public function getNetworks(): array
    {
        return $this->networks->getArrayCopy();
    }

    /**
     * @return Role
     */
    public function getRole(): Role
    {
        return $this->role;
    }

    /**
     * @return Token|null
     */
    public function getPasswordResetToken(): ?Token
    {
        return $this->passwordResetToken;
    }

    /**
     * @return Token|null
     */
    public function getJoinConfirmToken(): ?Token
    {
        return $this->joinConfirmToken;
    }

    /**
     * @return bool
     */
    public function isWait(): bool
    {
        return $this->status->isWait();
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->status->isActive();
    }

    /**
     * @param string $value
     * @param DateTimeImmutable $date
     *
     * @return void
     */
    public function confirmJoin(string $value, DateTimeImmutable $date): void
    {
        if ($this->joinConfirmToken === null) {
            throw new DomainException('Confirmation is not required');
        }

        $this->joinConfirmToken->validate($value, $date);
        $this->status = Status::active();
        $this->joinConfirmToken = null;
    }

    /**
     * @param NetworkIdentity $identity
     *
     * @return void
     */
    public function attachNetwork(NetworkIdentity $identity): void
    {
        /** @var NetworkIdentity $existing */
        foreach ($this->networks as $existing) {
            if ($existing->isEqualTo($identity)) {
                throw new DomainException('Network is already attached.');
            }
        }

        $this->networks->append($identity);
    }

    /**
     * @param Token $token
     * @param DateTimeImmutable $date
     *
     * @return void
     */
    public function requestPasswordReset(Token $token, DateTimeImmutable $date): void
    {
        if (!$this->isActive()) {
            throw new DomainException('User is not active');
        }

        if ($this->passwordResetToken !== null && !$this->passwordResetToken->isExpiredTo($date)) {
            throw  new DomainException('Resetting is already requested');
        }

        $this->passwordResetToken = $token;
    }

    /**
     * @param string $token
     * @param DateTimeImmutable $date
     * @param string $hash
     *
     * @return void
     */
    public function resetPassword(string $token, DateTimeImmutable $date, string $hash): void
    {
        if ($this->passwordResetToken === null) {
            throw new DomainException('Resetting is not requested');
        }

        $this->passwordResetToken->validate($token, $date);
        $this->passwordResetToken = null;
        $this->passwordHash = $hash;
    }

    /**
     * @param PasswordHasher $hasher
     * @param string $current
     * @param string $new
     *
     * @return void
     */
    public function changePassword(PasswordHasher $hasher, string $current, string $new): void
    {
        if ($this->passwordHash === null) {
            throw new DomainException('User does not have an old password');
        }

        if (!$hasher->validate($current, $this->passwordHash)) {
            throw new DomainException('Incorrect current password');
        }

        $this->passwordHash = $hasher->hash($new);
    }

    /**
     * @param $token
     * @param $date
     * @param $email
     *
     * @return void
     */
    public function requestEmailChanging($token, $date, $email): void
    {
        if (!$this->isActive()) {
            throw new DomainException('User is not active');
        }

        if ($this->email->isEqualTo($email)) {
            throw new DomainException('Email is already same');
        }

        if ($this->newEmailToken !== null && !$this->newEmailToken->isExpiredTo($date)) {
            throw new DomainException('Email is already requested');
        }

        $this->newEmail = $email;
        $this->newEmailToken = $token;
    }

    /**
     * @param string $token
     * @param DateTimeImmutable $date
     *
     * @return void
     */
    public function confirmEmailChanging(string $token, DateTimeImmutable $date)
    {
        if ($this->newEmail === null || $this->newEmailToken === null) {
            throw new DomainException('Changing is not required');
        }

        $this->newEmailToken->validate($token, $date);
        $this->email = $this->newEmail;
        $this->newEmail = null;
        $this->newEmailToken = null;
    }

    /**
     * @param Role $role
     *
     * @return void
     */
    public function changeRole(Role $role)
    {
        if ($this->role->isEqualTo($role)) {
            throw new DomainException('Role is already same');
        }

        $this->role = $role;
    }

    public function remove()
    {
        if (!$this->isWait()) {
            throw new DomainException('Unable to remove active user');
        }
    }
}
