<?php

namespace App\Controller;

use App\Component\User\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserCreateAction extends AbstractController
{
    public function __construct(private UserManager $userManager)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        // JSON ma'lumotlarni o'qish
        $content = $request->getContent();
        $data = json_decode($content, true);

        // JSON tekshirish
        if (json_last_error() !== JSON_ERROR_NONE) {
            return $this->json([
                'error' => 'Invalid JSON format',
                'message' => json_last_error_msg()
            ], 400);
        }

        // Majburiy maydonlarni tekshirish
        $requiredFields = ['email', 'password', 'fullname', 'surname', 'age'];
        $missingFields = [];

        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || $data[$field] === '') {
                $missingFields[] = $field;
            }
        }

        if (!empty($missingFields)) {
            return $this->json([
                'error' => 'Missing required fields',
                'missing_fields' => $missingFields
            ], 400);
        }

        try {
            // User yaratish
            $user = $this->userManager->createUser(
                $data['email'],
                $data['password'],
                $data['fullname'],
                $data['surname'],
                (int)$data['age']
            );

            // JSON response qaytarish
            return $this->json([
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'fullname' => $user->getFullname(),
                'surname' => $user->getSurname(),
                'age' => $user->getAge(),
                'message' => 'User muvaffaqiyatli yaratildi'
            ], 201);

        } catch (\Exception $e) {
            return $this->json([
                'error' => 'Server error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}

































