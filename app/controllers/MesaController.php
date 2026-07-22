<?php

declare(strict_types=1);

/**
 * Gestiona el módulo administrativo de mesas.
 */
final class MesaController extends Controller
{
    public function index(): void
    {
        AuthMiddleware::requirePermission('mesas.view');

        $model = new Mesa();
        $editId = (int) ($_GET['editar'] ?? 0);

        $this->view('admin/mesas', [
            'title' => 'Mesas | RMRS',
            'user' => AuthMiddleware::user(),
            'modules' => [],
            'mesas' => $model->all(),
            'mesaEdit' => $editId > 0 ? $model->find($editId) : false,
            'canManage' => AuthMiddleware::can('mesas.manage'),
        ], 'dashboard');
    }

    public function save(): void
    {
        AuthMiddleware::requirePermission('mesas.manage');

        if (!Security::verifyCsrf($_POST['csrf_token'] ?? null)) {
            Session::flash('error', 'La sesión expiró. Inténtalo nuevamente.');
            $this->redirect('/mesas');
        }

        $data = [
            'id' => (int) ($_POST['id'] ?? 0),
            'codigo' => strtoupper(trim((string) ($_POST['codigo'] ?? ''))),
            'capacidad' => (int) ($_POST['capacidad'] ?? 0),
            'ubicacion' => trim((string) ($_POST['ubicacion'] ?? '')),
            'estado' => trim((string) ($_POST['estado'] ?? '')),
        ];

        $allowedStates = ['Libre', 'Reservada', 'Ocupada', 'Limpieza'];

        if (
            !preg_match('/^[A-Z0-9-]{2,20}$/', $data['codigo'])
            || $data['capacidad'] < 1
            || $data['capacidad'] > 20
            || $data['ubicacion'] === ''
            || !in_array($data['estado'], $allowedStates, true)
        ) {
            Session::flash('error', 'Verifica los datos de la mesa.');
            $this->redirect('/mesas');
        }

        try {
            (new Mesa())->save($data);

            Session::flash(
                'success',
                $data['id'] > 0
                    ? 'Mesa actualizada correctamente.'
                    : 'Mesa creada correctamente.'
            );
        } catch (Throwable $exception) {
            Session::flash('error', 'No se pudo guardar la mesa. El código podría estar repetido.');
        }

        $this->redirect('/mesas');
    }

    public function delete(): void
    {
        AuthMiddleware::requirePermission('mesas.manage');

        if (!Security::verifyCsrf($_POST['csrf_token'] ?? null)) {
            $this->redirect('/mesas');
        }

        try {
            (new Mesa())->delete((int) ($_POST['id'] ?? 0));
            Session::flash('success', 'Mesa eliminada correctamente.');
        } catch (Throwable $exception) {
            Session::flash('error', $exception->getMessage());
        }

        $this->redirect('/mesas');
    }
}