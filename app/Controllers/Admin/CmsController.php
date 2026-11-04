<?php
namespace App\Controllers\Admin;

use App\Models\CmsPage;
use App\Helpers\View;
use App\Helpers\Csrf;
use App\Helpers\Session;
use App\Middleware\AdminMiddleware;
use App\Config\App;

class CmsController {
    public static function index(): void {
        AdminMiddleware::check();
        $pages = CmsPage::all('id ASC');

        View::render('admin/cms/index', [
            'breadcrumb' => 'CMS Pages',
            'title' => 'Content Pages',
            'pages' => $pages
        ], 'admin');
    }

    public static function edit(): void {
        AdminMiddleware::check();
        $id = (int)($_GET['id'] ?? 0);
        $page = CmsPage::find($id);
        if (!$page) die("Page not found");

        View::render('admin/cms/edit', [
            'breadcrumb' => 'Edit ' . $page['title'],
            'title' => 'Edit CMS Page',
            'page' => $page
        ], 'admin');
    }

    public static function update(): void {
        AdminMiddleware::check();
        if (!Csrf::verify($_POST['csrf_token'] ?? '')) die("Security error.");

        $id = (int)($_POST['id'] ?? 0);
        CmsPage::update($id, [
            'title' => trim($_POST['title'] ?? ''),
            'content_html' => $_POST['content_html'] ?? ''
        ]);

        Session::setFlash('admin_success', 'Page content updated successfully.');
        header('Location: ' . App::baseUrl('admin/cms'));
        exit;
    }
}
