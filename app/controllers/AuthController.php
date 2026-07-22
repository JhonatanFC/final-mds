<?php

declare(strict_types=1);

/**
 * Gestiona el inicio y cierre de sesión.
 */
final class AuthController extends Controller
{
    /**
     * Muestra el formulario de acceso.
     */
    public function showLogin(): void
    {
        if (Session::has('user')) {
            $this->redirect('/dashboard');
        }

        $this->view('auth/login', [
            'title' => 'Iniciar sesión | RMRS',
        ], 'auth');
    }

    /**
     * Procesa las credenciales enviadas por el formulario.
     */
    public function login(): void
    {
        if (!Security::verifyCsrf($_POST['csrf_token'] ?? null)) {
            Session::flash('error', 'La sesión expiró. Inténtalo nuevamente.');
            $this->redirect('/login');
        }

        $email = trim((string) ($_POST['correo'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');

        if (!Validator::email($email) || !Validator::required($password)) {
            Session::flash('error', 'Ingresa un correo y contraseña válidos.');
            $this->redirect('/login');
        }

        $usuarioModel = new Usuario();
        $user = $usuarioModel->findActiveByEmail($email);

        if ($user === false || !$usuarioModel->verifyPassword($user, $password)) {
            Session::flash('error', 'Las credenciales son incorrectas.');
            $this->redirect('/login');
        }

        Session::regenerate();

        Session::set('user', [
            'id' => (int) $user['id'],
            'rol_id' => (int) $user['rol_id'],
            'nombres' => (string) $user['nombres'],
            'correo' => (string) $user['correo'],
            'rol' => (string) $user['rol_nombre'],
        ]);

        $this->redirect('/dashboard');
    }

    /**
     * Cierra la sesión autenticada.
     */
    public function logout(): void
    {
        if (!Security::verifyCsrf($_POST['csrf_token'] ?? null)) {
            $this->redirect('/dashboard');
        }

        Session::destroy();
        Session::start();
        Session::flash('success', 'Sesión cerrada correctamente.');

        $this->redirect('/login');
    }
}