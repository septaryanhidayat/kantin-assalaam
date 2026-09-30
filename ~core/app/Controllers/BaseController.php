<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\AdminModel;
use App\Models\OrtuModel;
use App\Models\SiswaModel;
use App\Models\SettingModel;
use App\Models\KantinModel;
use App\Models\BarangModel;
use App\Models\DepositModel;
use App\Models\TransaksiModel;
use App\Models\Transaksi_detailModel;
use App\Models\NotifikasiModel;
use App\Models\Landing_headerModel;
use App\Models\Landing_featuredModel;
use App\Models\Landing_kepala_sekolahModel;
use App\Models\Landing_galleryModel;
use App\Models\Landing_footerModel;
use App\Models\GuruModel;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;
    protected $session;
    protected $admin;
    protected $siswa;
    protected $ortu;
    protected $kantin;
    protected $setting;
    protected $barang;
    protected $deposit;
    protected $transaksi;
    protected $transaksi_detail;
    protected $notifikasi;
    protected $landing_header;
    protected $landing_featured;
    protected $landing_kepala_sekolah;
    protected $landing_gallery;
    protected $landing_footer;
    protected $guru;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['fungsi'];

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        $this->session = \Config\Services::session();

        //Load Model
        $this->admin                  = new AdminModel();
        $this->siswa                  = new SiswaModel();
        $this->ortu                   = new OrtuModel();
        $this->setting                = new SettingModel();
        $this->kantin                 = new KantinModel();
        $this->barang                 = new BarangModel();
        $this->deposit                = new DepositModel();
        $this->transaksi              = new TransaksiModel();
        $this->transaksi_detail       = new Transaksi_detailModel();
        $this->notifikasi             = new NotifikasiModel();
        $this->guru                   = new GuruModel();
        $this->landing_header         = new Landing_headerModel();
        $this->landing_featured       = new Landing_featuredModel();
        $this->landing_kepala_sekolah = new Landing_kepala_sekolahModel();
        $this->landing_gallery        = new Landing_galleryModel();
        $this->landing_footer         = new Landing_footerModel();
    }
}
