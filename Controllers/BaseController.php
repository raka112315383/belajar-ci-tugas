<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\DiscountModel; // PENTING: Import DiscountModel

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 * class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    protected $session; // PENTING: Aktifkan properti session
    protected $discountModel; // PENTING: Deklarasikan properti untuk DiscountModel

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = service('session');
        $this->session = service('session'); // PENTING: Inisialisasi session service
        $this->discountModel = new DiscountModel(); // PENTING: Inisialisasi DiscountModel

        // --- LOGIKA PENCARIAN & PENYIMPANAN DISKON KE SESSION ---
        // Mendapatkan tanggal hari ini dalam format YYYY-MM-DD
        // Menggunakan date() karena Time::now() mungkin belum terdefinisi di BaseController jika tidak di-import
        $today = date('Y-m-d'); 
        
        // Mencari diskon berdasarkan tanggal hari ini
        $discountToday = $this->discountModel->where('tanggal', $today)->first();

        if ($discountToday) {
            // Jika diskon ditemukan, simpan nominalnya ke session reguler (bukan flashdata)
            $this->session->set('today_discount', $discountToday['nominal']);
        } else {
            // Jika tidak ada diskon hari ini, hapus dari session
            $this->session->remove('today_discount');
        }
        // --- AKHIR LOGIKA DISKON ---
        }
}