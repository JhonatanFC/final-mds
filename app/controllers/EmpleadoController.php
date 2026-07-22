<?php

declare(strict_types=1);

final class EmpleadoController extends Controller
{
    public function index(): void
    {
        $this->ensureAdministrator();

        $model = new Empleado();

        $this->view('admin/usuarios', [
            'title' => 'Usuarios internos | RMRS',
            'user' => AuthMiddleware::user(),
            'employees' => $model->getAll(),
            'roles' => $model->getRoles(),
            'csrfToken' => Security::csrfToken(),
        ], 'dashboard');
    }

    public function store(): void
    {
        $this->ensureAdministrator();

        if (!Security::verifyCsrf($_POST['csrf_token'] ?? null)) {
            Session::flash('error', 'La sesión expiró. Actualiza la página e inténtalo nuevamente.');
            redirect('/usuarios');
        }

        try {
            (new Empleado())->create(
                (int) ($_POST['rol_id'] ?? 0),
                trim((string) ($_POST['nombres'] ?? '')),
                trim((string) ($_POST['correo'] ?? '')),
                (string) ($_POST['password'] ?? '')
            );

            Session::flash('success', 'Empleado registrado correctamente.');
        } catch (Throwable $exception) {
            Session::flash('error', $exception->getMessage());
        }

        redirect('/usuarios');
    }

    public function toggleStatus(): void
    {
        $this->ensureAdministrator();

        if (!Security::verifyCsrf($_POST['csrf_token'] ?? null)) {
            Session::flash('error', 'La sesión expiró. Actualiza la página e inténtalo nuevamente.');
            redirect('/usuarios');
        }

        try {
            (new Empleado())->toggleStatus((int) ($_POST['usuario_id'] ?? 0));
            Session::flash('success', 'Estado del empleado actualizado.');
        } catch (Throwable $exception) {
            Session::flash('error', $exception->getMessage());
        }

        redirect('/usuarios');
    }

    private function ensureAdministrator(): void
    {
        $user = AuthMiddleware::user();

        if ($user === null || ($user['rol'] ?? '') !== 'Administrador') {
            Session::flash('error', 'No tienes permisos para administrar usuarios.');
            redirect('/dashboard');
        }
    }
}