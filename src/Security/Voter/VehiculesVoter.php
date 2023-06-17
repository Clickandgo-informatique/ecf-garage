<?php

namespace App\Security\Voter;

use App\Entity\Users;
use App\Entity\Vehicules;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class VehiculesVoter extends Voter
{
    public const EDIT = 'vehicule_edit';

    public const DELETE = 'vehicule_delete';

    protected function supports(string $attribute, mixed $vehicule): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::DELETE])
            && $vehicule instanceof \App\Entity\Vehicules;
    }

    protected function voteOnAttribute(string $attribute, mixed $vehicule, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }



        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
                // Détermine si l'utilisateur peut éditer la fiche véhicule
                // return true or false
                break;
            case self::DELETE:
                // logic to determine if the user can VIEW
                // return true or false
                break;
        }

        return false;
    }

    private function canEdit(Vehicules $vehicule, Users $user)
    {
        return $user === $vehicule->getUsers();
    }

    private function canDelete(Vehicules $vehicule, Users $user)
    {
    }
}
