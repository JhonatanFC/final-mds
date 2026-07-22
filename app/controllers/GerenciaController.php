<?php

declare(strict_types=1);

final class GerenciaController extends Controller
{
    public function index(): void
    {
        AuthMiddleware::requirePermission('reportes');

        $reportModel = new Reporte();

        $this->view('gerente/dashboard', [
            'title' => 'Gerencia | RMRS',
            'user' => AuthMiddleware::user(),
            'metrics' => $reportModel->getTodayMetrics(),
            'weeklySales' => $reportModel->getWeeklySales(),
            'topProducts' => $reportModel->getTopProducts(),
            'recentSales' => $reportModel->getRecentSales(),
        ], 'dashboard');
    }
}