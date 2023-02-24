<?php

namespace App\EntityListener;

use App\Entity\ProfilUser;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserListener
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher) 
    {
        $this->hasher = $hasher;
    }

    public function prePersist(ProfilUser $user)
    {
        $this->encodePassword($user);
    }

    public function preUpdate(ProfilUser $user)
    {
        $this->encodePassword($user);
    }

    /**
     * Encodage mot de passe avec plain password
     *
     * @param ProfilUser $user
     * @return void
     */
    public function encodePassword(ProfilUser $user)
    {
        if ($user->getPlainPassword() === null) {
            return;
        }

        $user->setPassword(
            $this->hasher->hashPassword(
                $user,
                $user->getPlainPassword()
            )
            );
            
            $user->setPlainPassword(null);
    }
}
