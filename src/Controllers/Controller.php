<?php

namespace src\Controllers;

use config\Database;
use src\Models\User;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class Controller
{

    private $loader;
    protected $twig;
    protected $db;

    public function __construct(Database $db)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->loader = new FilesystemLoader(ROOT . "/templates");

        $this->twig = new Environment($this->loader);

        $this->db = $db;
        $this->twig->addGlobal('__get', $_GET);
        $this->twig->addGlobal('__session', $_SESSION);

    }

    protected function getDb()
    {
        return $this->db;
    }

    /**
     * Vérifie si on a une session ouverte sinon on redirige vers la page d'accueil
     *
     * @return void
     */
    public function userSession()
    {
        if (isset($_SESSION['login'])) {
            return (new User($this->db))->findByLogin($_SESSION['login']);
        }
        return header("Location: /");
    }

    /**
     * La fonction qui permet d'téléverser un fichier dans le server
     *
     * @param string $fileKey | le nom de l'input file
     * @param string $userName | le nom de l'utilisateur. celui qui sera donnée au fichier
     * @param array $fileExtensionsAllowed | un tableau des extensions à accepter
     * @return string
     */
    public function uploadFile(string $fileKey, string $userName, array $fileExtensionsAllowed): string
    {
        $currentDirectory = getcwd();
        $uploadDirectory = DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR;

        $errors = []; // Store errors here
        // $fileExtensionsAllowed = ['jpeg', 'jpg', 'png', 'gif']; // These will be the only file extensions allowed
        $fileName = $_FILES[$fileKey]['name'];
        $fileSize = $_FILES[$fileKey]['size'];
        $fileTmpName = $_FILES[$fileKey]['tmp_name'];
        $fileExtension = strtolower(explode(".", $fileName)[1]);
        $fileName = $userName . "." . $fileExtension;
        $uploadPath = $currentDirectory . $uploadDirectory . basename($fileName);
        if (!in_array($fileExtension, $fileExtensionsAllowed)) {
            $errors[] = "This file extension is not allowed. Please upload a JPEG or PNG file";
        }
        if ($fileSize > 4000000) {
            $errors[] = "File exceeds maximum size (4MB)";
        }
        if (empty($errors)) {
            $didUpload = move_uploaded_file($fileTmpName, $uploadPath);
            if ($didUpload) {
                return $fileName;
            } else {
                echo "An error occurred. Please contact the administrator.";
            }
        } else {
            foreach ($errors as $error) {
                echo $error . "These are the errors" . "\n";
            }
        }
        return $errors;
    }
}