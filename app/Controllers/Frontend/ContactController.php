<?php

require_once APP_PATH . '/Controllers/BaseController.php';

/**
 * ContactController - Form Kontak & Whistleblowing
 */
class ContactController extends BaseController
{
    private Security $security;

    public function __construct()
    {
        parent::__construct();
        $this->security = new Security($this->db);
    }

    public function index(): void
    {
        log_visitor($this->db);
        $settings = $this->getSettings();

        $this->render('frontend.layouts.main', 'frontend.pages.contact', [
            'title'         => 'Hubungi Kami | ' . ($settings['site_name'] ?? ''),
            'settings'      => $settings,
            'csrf'          => $this->security->csrfField(),
            'flash_success' => flash('success'),
            'flash_error'   => flash('error'),
            'active'        => 'kontak',
        ]);
    }

    public function store(): void
    {
        try {
            $this->verifyCsrf();
        } catch (RuntimeException) {
            set_flash('error', 'Request tidak valid.');
            redirect('/hubungi-kami');
        }

        $rules = [
            'name'    => 'required|min:2|max:100',
            'email'   => 'required|email',
            'message' => 'required|min:10|max:5000',
        ];

        $validation = Security::validate($_POST, $rules);
        if ($validation !== true) {
            set_flash('error', implode(' ', array_merge(...array_values($validation))));
            redirect('/hubungi-kami');
        }

        $stmt = $this->db->prepare("
            INSERT INTO contacts (name, email, phone, subject, message, type, ip_address)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            Security::sanitize($_POST['name'] ?? ''),
            Security::sanitize($_POST['email'] ?? '', 'email'),
            Security::sanitize($_POST['phone'] ?? ''),
            Security::sanitize($_POST['subject'] ?? ''),
            Security::sanitize($_POST['message'] ?? '', 'html'),
            Security::sanitize($_POST['type'] ?? 'general'),
            get_client_ip(),
        ]);

        set_flash('success', 'Pesan Anda telah berhasil dikirim. Kami akan menghubungi Anda segera.');
        redirect('/hubungi-kami');
    }

    public function whistleblow(): void
    {
        log_visitor($this->db);
        $settings = $this->getSettings();

        $this->render('frontend.layouts.main', 'frontend.pages.whistleblowing', [
            'title'         => 'Whistleblowing System | ' . ($settings['site_name'] ?? ''),
            'settings'      => $settings,
            'csrf'          => $this->security->csrfField(),
            'flash_success' => flash('success'),
            'flash_error'   => flash('error'),
            'active'        => 'kontak',
        ]);
    }

    public function storeWhistleblow(): void
    {
        try {
            $this->verifyCsrf();
        } catch (RuntimeException) {
            set_flash('error', 'Request tidak valid.');
            redirect('/whistleblowing');
        }

        $isAnonymous = isset($_POST['is_anonymous']) && $_POST['is_anonymous'] === '1';

        $rules = [
            'category'    => 'required|in:korupsi,penipuan,pelanggaran,lainnya',
            'description' => 'required|min:20|max:10000',
        ];
        if (!$isAnonymous) {
            $rules['email'] = 'required|email';
        }

        $validation = Security::validate($_POST, $rules);
        if ($validation !== true) {
            set_flash('error', implode(' ', array_merge(...array_values($validation))));
            redirect('/whistleblowing');
        }

        // Handle attachment
        $attachmentFile = null;
        if (!empty($_FILES['attachment']['name'])) {
            try {
                $attachmentFile = $this->security->uploadFile(
                    $_FILES['attachment'],
                    'whistleblows',
                    ['image/jpeg', 'image/png', 'application/pdf']
                );
            } catch (RuntimeException $e) {
                set_flash('error', 'Gagal upload lampiran: ' . $e->getMessage());
                redirect('/whistleblowing');
            }
        }

        $stmt = $this->db->prepare("
            INSERT INTO whistleblows (name, email, phone, category, description, attachment, is_anonymous)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $isAnonymous ? null : Security::sanitize($_POST['name'] ?? ''),
            $isAnonymous ? null : Security::sanitize($_POST['email'] ?? '', 'email'),
            $isAnonymous ? null : Security::sanitize($_POST['phone'] ?? ''),
            Security::sanitize($_POST['category'] ?? ''),
            Security::sanitize($_POST['description'] ?? '', 'html'),
            $attachmentFile,
            (int) $isAnonymous,
        ]);

        set_flash('success', 'Laporan Anda telah berhasil dikirim. Kami akan menindaklanjuti dengan segera.');
        redirect('/whistleblowing');
    }
}
