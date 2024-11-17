<?php

namespace app\controllers;

use app\core\BaseController;
use app\models\UserModel;

class UserController extends BaseController
{
    /**
     * Retrieves a single user by ID.
     */
    public function readUser()
    {
        $model = new UserModel();

        // Retrieve user with id = 2 safely
        $model->one("where id = :id", ['id' => 2]);

        $this->view->render('getUser', 'main', $model);
    }

    /**
     * Retrieves all users.
     */
    public function readAll()
    {
        $model = new UserModel();

        // Retrieve all users
        $results = $model->all("");

        $this->view->render('users', 'main', $results);
    }

    /**
     * Loads a user by ID and prepares it for update.
     */
    public function updateUser()
    {
        $model = new UserModel();

        // Map data from GET and validate ID
        $model->mapData($_GET);

        if (isset($model->id) && is_numeric($model->id)) {
            $model->one("where id = :id", ['id' => $model->id]);
        } else {
            // If ID is invalid, redirect with error or handle gracefully
            header("location: /users?error=Invalid ID");
            exit;
        }

        $this->view->render('updateUser', 'main', $model);
    }

    /**
     * Processes the update of a user.
     */
    public function processUpdateUser()
    {
        $model = new UserModel();

        // Map data from POST request
        $model->mapData($_POST);

        // Validate ID before updating
        if (isset($model->id) && is_numeric($model->id)) {
            $model->update("where id = :id", ['id' => $model->id]);
            header("location: /users?success=User updated");
        } else {
            // Redirect back with error if ID is invalid
            header("location: /updateUser?id=" . $model->id . "&error=Invalid ID");
        }
    }

    /**
     * Renders the user creation form.
     */
    public function createUser()
    {
        $model = new UserModel();
        $this->view->render('createUser', 'main', $model);
    }

    /**
     * Processes the creation of a new user.
     */
    public function processCreate()
    {
        $model = new UserModel();

        // Map data from POST request
        $model->mapData($_POST);

        // Perform validation
        $model->validate();

        if ($model->errors) {
            // Render form again with errors
            $this->view->render('createUser', 'main', $model);
            exit;
        }

        // Insert new user into database
        $model->insert();
        header("location: /users?success=User created");
    }
}
