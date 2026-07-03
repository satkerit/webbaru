<?php

/**
 * RBAC Helper - Role Based Access Control
 */
class RBAC
{
    private PDO $db;
    private int $userId;
    private int $roleId = 0;
    private array $permissions = [];

    public function __construct(PDO $db, int $userId)
    {
        $this->db     = $db;
        $this->userId = $userId;
        $this->loadUserPermissions();
    }

    private function loadUserPermissions(): void
    {
        // Ambil role_id
        $stmt = $this->db->prepare("SELECT role_id FROM users WHERE id = ? AND is_active = 1");
        $stmt->execute([$this->userId]);
        $user = $stmt->fetch();

        if (!$user) return;

        $this->roleId = (int) $user['role_id'];

        // Permission dari role
        $stmt = $this->db->prepare("
            SELECT p.name
            FROM permissions p
            JOIN role_permissions rp ON p.id = rp.permission_id
            WHERE rp.role_id = ?
        ");
        $stmt->execute([$this->roleId]);
        $rolePerms = $stmt->fetchAll(PDO::FETCH_COLUMN);

        // Permission khusus user
        $stmt = $this->db->prepare("
            SELECT p.name
            FROM permissions p
            JOIN user_permissions up ON p.id = up.permission_id
            WHERE up.user_id = ? AND up.granted = 1
        ");
        $stmt->execute([$this->userId]);
        $userPerms = $stmt->fetchAll(PDO::FETCH_COLUMN);

        $this->permissions = array_unique(array_merge($rolePerms, $userPerms));
    }

    public function hasPermission(string $permission): bool
    {
        return in_array($permission, $this->permissions, true);
    }

    public function hasAnyPermission(array $permissions): bool
    {
        foreach ($permissions as $perm) {
            if ($this->hasPermission($perm)) return true;
        }
        return false;
    }

    public function requirePermission(string $permission): void
    {
        if (!$this->hasPermission($permission)) {
            http_response_code(403);
            // Jika request JSON
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
                header('Content-Type: application/json');
                echo json_encode(['error' => 'Akses ditolak.']);
                exit;
            }
            $_SESSION['flash_error'] = 'Anda tidak memiliki izin untuk mengakses halaman ini.';
            header('Location: /admin/dashboard');
            exit;
        }
    }

    public function requireAnyPermission(array $permissions): void
    {
        if (!$this->hasAnyPermission($permissions)) {
            http_response_code(403);
            $_SESSION['flash_error'] = 'Anda tidak memiliki izin untuk mengakses halaman ini.';
            header('Location: /admin/dashboard');
            exit;
        }
    }

    public function hasRole(string $roleName): bool
    {
        $stmt = $this->db->prepare("SELECT id FROM roles WHERE name = ?");
        $stmt->execute([$roleName]);
        $role = $stmt->fetch();
        return $role && (int) $role['id'] === $this->roleId;
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function getPermissions(): array
    {
        return $this->permissions;
    }

    public function getRoleId(): int
    {
        return $this->roleId;
    }
}
