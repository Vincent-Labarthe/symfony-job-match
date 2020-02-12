<?php 

namespace App\Security\Recruiter;

use App\Entity\JobApplication;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class JobApplicationVoter extends Voter
{
    // these strings are just invented: you can use anything
    const VIEW = 'view';
    const EDIT = 'edit';

    protected function supports($attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::VIEW, self::EDIT])) {
            return false;
        }

        // only vote on Post objects inside this voter
        if (!$subject instanceof JobApplication) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        // you know $subject is a Post object, thanks to supports
        /** @var JobApplication $post */
        $jobApplication = $subject;

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($jobApplication, $user);
            case self::EDIT:
                return $this->canEdit($jobApplication, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canView(JobApplication $jobApplication, User $user)
    {
        // if they can edit, they can view
        if ($this->canEdit($jobApplication, $user)) {
            return true;
        }

    }

    private function canEdit(JobApplication $jobApplication, User $user)
    {
        // this assumes that the data object has a getOwner() method
        // to get the entity of the user who owns this data object
        return $user === $jobApplication->getUser();
    }
}
