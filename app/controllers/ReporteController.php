<?php

declare(strict_types=1);

final class ReporteController extends Controller
{
    public function index(): void
    {
        AuthMiddleware::requirePermission('reportes');

        $date = trim((string) ($_GET['fecha'] ?? date('Y-m-d')));

        $dateTime = DateTimeImmutable::createFromFormat('Y-m-d', $date);

        if ($dateTime === false || $dateTime->format('Y-m-d') !== $date) {
            $date = date('Y-m-d');
        }

        $reportModel = new Reporte();

        $this->view('gerente/reportes', [
            'title' => 'Reportes | RMRS',
            'user' => AuthMiddleware::user(),
            'date' => $date,
            'summary' => $reportModel->getSummary($date),
            'salesByMethod' => $reportModel->getSalesByMethod($date),
            'topProducts' => $reportModel->getTopProducts($date),
            'dailySales' => $reportModel->getDailySales($date),
            'recentCharges' => $reportModel->getRecentCharges($date),
        ], 'dashboard');
    }
}