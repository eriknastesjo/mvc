<?php

/**
 * Module with GardenController class.
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;

use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Garden\ConvertStrings;

use App\Garden\Database;

/**
 * Controls the routes of Garden pages.
 */
class UserController extends AbstractController
{
    /**
     * Register new user
     * @Route("/proj/register", name="register-process", methods={"POST"})
     */
    public function registerProcess(
        ManagerRegistry $doctrine,
        Request $request,
        SessionInterface $session,
        UserRepository $userRep
    ) {
        $convStr = new ConvertStrings;

        $firstName = $request->get('fname');
        $lastName = $request->get('lname');
        $password = $request->get('password');

        if (strlen($firstName) >= 2 && strlen($lastName) >= 2) {
            $db = new Database;

            $newAcronym = substr($convStr->fromSwe(strtolower($firstName)), 0, 2)
                . substr($convStr->fromSwe(strtolower($lastName)), 0, 2);

            $newAcronym = $db->newAcronymToDB($userRep, $newAcronym);

            $newUser = $db->addToTableUser($doctrine, $newAcronym, $password, $firstName, $lastName);
            $session->set("userId", $newUser->getId());
        }
        return $this->redirectToRoute('garden-home');
    }

    /**
     * Checking login data.
     * Log in if meeting criterias.
     * @Route("/proj/login", name="login-process", methods={"POST"})
     */
    public function logInProcess(
        Request $request,
        SessionInterface $session,
        UserRepository $userRep
    ) {
        $acronymName = $request->get('acronym');
        $password = $request->get('password');

        $db = new Database;
        $user = $db->getUserThroughAcrAndPassw($userRep, $acronymName, $password);

        if ($user) {
            $session->set("userId", $user->getId());
            if ($user->getStatus() === "admin") {
                $session->set("isAdmin", true);
            }
        }

        return $this->redirectToRoute('garden-home');
    }

    /**
     * Renders editing profile page.
     * @Route("/proj/editProfile", name="garden-edit-profile", methods={"GET","HEAD"})
     */
    public function editProfile(UserRepository $userRep, SessionInterface $session): Response
    {

        $userId = $session->get("userId");

        $data = [
            'userId' => null,
            'fName' => null,
            'lName' => null,
            'imgURL' => null,
            'description' => null
        ];

        // find row info from table User
        if ($userId) {
            $db = new Database;
            $row = $db->getRowByIdTableUser($userRep, $userId);
            $data = [
                'userId' => $userId,
                'fName' => $row->getFirstName(),
                'lName' => $row->getLastName(),
                'imgURL' => $row->getImgURL(),
                'description' => $row->getDescription()
            ];
        }

        return $this->render('garden/editProfile.html.twig', $data);
    }

    /**
     * Admin can edit users from here
     * @Route("/proj/editUsers", name="garden-edit-users", methods={"GET","HEAD"})
     */
    public function editUsers(UserRepository $userRep, SessionInterface $session): Response
    {
        $isAdmin = $session->get("isAdmin");
        $db = new Database();

        $data = [
            'isAdmin' => null,
            'tableUsers' => null
        ];

        $tableUsers = $db->getTableUsers($userRep);
        if ($isAdmin) {
            $data = [
                'isAdmin' => $isAdmin,
                'tableUsers' => $tableUsers
            ];
        }

        return $this->render('garden/editUsers.html.twig', $data);
    }


    /**
     * Update user info
     * @Route("/proj/user-update", name="user-update", methods={"POST"})
     */
    public function userUpdateProcess(
        ManagerRegistry $doctrine,
        Request $request,
        UserRepository $userRep,
        SessionInterface $session
    ) {
        $userId = $session->get("userId");
        $description = $request->get('description');
        $imgURL = $request->get('imgURL');

        $db = new Database;
        $db->updateUserInfo($doctrine, $userRep, $userId, $description, $imgURL);

        return $this->redirectToRoute('garden-home');
    }

    /**
     * Log out by setting session variable userId to null
     * @Route("/proj/logout", name="logout-process", methods={"POST"})
     */
    public function logOutProcess(
        SessionInterface $session
    ) {
        $session->set("userId", null);
        $session->set("isAdmin", false);
        return $this->redirectToRoute('garden-home');
    }
}
