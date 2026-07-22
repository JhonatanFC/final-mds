<?php

declare(strict_types=1);

final class ProductoController extends Controller
{
    public function index(): void
    {
        AuthMiddleware::requirePermission('productos.view');

        $productoModel = new Producto();
        $categoriaModel = new Categoria();

        $productEditId = (int) ($_GET['editar_producto'] ?? 0);
        $categoryEditId = (int) ($_GET['editar_categoria'] ?? 0);

        $this->view('admin/productos', [
            'title' => 'Productos | RMRS',
            'user' => AuthMiddleware::user(),
            'modules' => [],
            'canManage' => AuthMiddleware::can('productos.manage'),
            'productos' => $productoModel->all(),
            'categorias' => $categoriaModel->all(),
            'productoEdit' => $productEditId > 0 ? $productoModel->find($productEditId) : false,
            'categoriaEdit' => $categoryEditId > 0 ? $categoriaModel->find($categoryEditId) : false,
        ], 'dashboard');
    }

    public function saveProduct(): void
    {
        AuthMiddleware::requirePermission('productos.manage');
        $this->verifyCsrf();

        $id = (int) ($_POST['id'] ?? 0);
        $existing = $id > 0 ? (new Producto())->find($id) : false;

        $data = [
            'id' => $id,
            'categoria_id' => (int) ($_POST['categoria_id'] ?? 0),
            'nombre' => trim((string) ($_POST['nombre'] ?? '')),
            'descripcion' => trim((string) ($_POST['descripcion'] ?? '')),
            'precio' => (float) ($_POST['precio'] ?? 0),
            'stock' => (int) ($_POST['stock'] ?? 0),
            'activo' => isset($_POST['activo']) ? 1 : 0,
            'imagen' => $existing['imagen'] ?? null,
        ];

        if (
            $data['categoria_id'] <= 0
            || $data['nombre'] === ''
            || $data['precio'] < 0
            || $data['stock'] < 0
        ) {
            Session::flash('error', 'Verifica los datos del producto.');
            $this->redirect('/productos');
        }

        try {
            $data['imagen'] = $this->uploadImage($data['imagen']);
            (new Producto())->save($data);
            Session::flash('success', 'Producto guardado correctamente.');
        } catch (Throwable $exception) {
            Session::flash('error', $exception->getMessage());
        }

        $this->redirect('/productos');
    }

    public function saveCategory(): void
    {
        AuthMiddleware::requirePermission('productos.manage');
        $this->verifyCsrf();

        $data = [
            'id' => (int) ($_POST['id'] ?? 0),
            'nombre' => trim((string) ($_POST['nombre'] ?? '')),
            'descripcion' => trim((string) ($_POST['descripcion'] ?? '')),
            'activo' => isset($_POST['activo']) ? 1 : 0,
        ];

        if ($data['nombre'] === '') {
            Session::flash('error', 'El nombre de la categoría es obligatorio.');
            $this->redirect('/productos');
        }

        try {
            (new Categoria())->save($data);
            Session::flash('success', 'Categoría guardada correctamente.');
        } catch (Throwable) {
            Session::flash('error', 'No se pudo guardar la categoría.');
        }

        $this->redirect('/productos');
    }

    public function deleteProduct(): void
    {
        AuthMiddleware::requirePermission('productos.manage');
        $this->verifyCsrf();

        try {
            (new Producto())->delete((int) ($_POST['id'] ?? 0));
            Session::flash('success', 'Producto eliminado.');
        } catch (Throwable $exception) {
            Session::flash('error', $exception->getMessage());
        }

        $this->redirect('/productos');
    }

    private function verifyCsrf(): void
    {
        if (!Security::verifyCsrf($_POST['csrf_token'] ?? null)) {
            Session::flash('error', 'La sesión expiró.');
            $this->redirect('/productos');
        }
    }

    private function uploadImage(?string $currentImage): ?string
    {
        $file = $_FILES['imagen'] ?? null;

        if (!is_array($file) || $file['error'] === UPLOAD_ERR_NO_FILE) {
            return $currentImage;
        }

        if ($file['error'] !== UPLOAD_ERR_OK || $file['size'] > 2 * 1024 * 1024) {
            throw new RuntimeException('La imagen supera el límite de 2 MB.');
        }

        $mime = (new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
        $extensions = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
        ];

        if (!isset($extensions[$mime])) {
            throw new RuntimeException('La imagen debe ser JPG, PNG o WEBP.');
        }

        $filename = bin2hex(random_bytes(16)) . '.' . $extensions[$mime];
        $path = BASE_PATH . '/uploads/productos/' . $filename;

        if (!move_uploaded_file($file['tmp_name'], $path)) {
            throw new RuntimeException('No se pudo guardar la imagen.');
        }

        return $filename;
    }
}