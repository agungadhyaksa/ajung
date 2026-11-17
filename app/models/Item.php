<?php
require_once __DIR__ . '/../../config/database.php';

class Item {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getAll(string $search = '', string $category = ''): array {
        $sql = "SELECT items.*, users.username as author FROM items 
                LEFT JOIN users ON items.user_id = users.id WHERE 1=1";
        $params = [];

        if (!empty($search)) {
            $sql .= " AND (items.title LIKE ? OR items.description LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
        }

        if (!empty($category)) {
            $sql .= " AND items.category = ?";
            $params[] = $category;
        }

        $sql .= " ORDER BY items.id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM items WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        $item = $stmt->fetch();
        return $item ?: null;
    }

    public function create(int $userId, string $title, string $category, string $status, string $description): bool {
        $stmt = $this->db->prepare("INSERT INTO items (user_id, title, category, status, description) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$userId, $title, $category, $status, $description]);
    }

    public function update(int $id, string $title, string $category, string $status, string $description): bool {
        $stmt = $this->db->prepare("UPDATE items SET title = ?, category = ?, status = ?, description = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
        return $stmt->execute([$title, $category, $status, $description, $id]);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM items WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getStats(): array {
        $total = $this->db->query("SELECT COUNT(*) FROM items")->fetchColumn();
        $active = $this->db->query("SELECT COUNT(*) FROM items WHERE status = 'active'")->fetchColumn();
        $pending = $this->db->query("SELECT COUNT(*) FROM items WHERE status = 'pending'")->fetchColumn();
        $completed = $this->db->query("SELECT COUNT(*) FROM items WHERE status = 'completed'")->fetchColumn();

        return [
            'total' => (int)$total,
            'active' => (int)$active,
            'pending' => (int)$pending,
            'completed' => (int)$completed,
        ];
    }

    public function getRecent(int $limit = 5): array {
        $stmt = $this->db->prepare("SELECT items.*, users.username as author FROM items 
                                    LEFT JOIN users ON items.user_id = users.id 
                                    ORDER BY items.id DESC LIMIT ?");
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
