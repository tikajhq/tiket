<?php

declare(strict_types=1);

namespace Tiket\Mcp;

use PDO;
use PhpMcp\Server\Exception\McpServerException;
use RuntimeException;

final class TicketTools
{
    public function __construct(private readonly PDO $database)
    {
    }

    /**
     * Find tickets by ticket number or subject, newest first.
     *
     * @param string $search Optional text to match against the ticket number or subject.
     * @param int $limit Maximum number of tickets to return (1-50).
     * @return array<int, array<string, mixed>>
     */
    public function searchTickets(string $search = '', int $limit = 20): array
    {
        if ($limit < 1 || $limit > 50) {
            throw new RuntimeException('The limit must be between 1 and 50.');
        }

        if (strlen($search) > 200) {
            throw new RuntimeException('The search text must not exceed 200 characters.');
        }

        $sql = 'SELECT ticket_no, subject, status, priority, severity, created FROM tickets';
        if ($search !== '') {
            $sql .= ' WHERE ticket_no LIKE :ticket_no OR subject LIKE :subject';
        }
        $sql .= ' ORDER BY created DESC, id DESC LIMIT :limit';

        $statement = $this->database->prepare($sql);
        if ($search !== '') {
            $pattern = '%' . $search . '%';
            $statement->bindValue(':ticket_no', $pattern, PDO::PARAM_STR);
            $statement->bindValue(':subject', $pattern, PDO::PARAM_STR);
        }
        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    /**
     * Read a ticket and its conversation by its ticket number.
     *
     * @param string $ticket_no The full ticket number.
     * @return array<string, mixed>
     */
    public function getTicket(string $ticket_no): array
    {
        $statement = $this->database->prepare(
            'SELECT ticket_no, subject, owner, purpose, message, assign_to, status, severity, priority, created, updated
             FROM tickets WHERE ticket_no = :ticket_no LIMIT 1'
        );
        $statement->execute(['ticket_no' => $ticket_no]);
        $ticket = $statement->fetch();

        if ($ticket === false) {
            throw McpServerException::invalidParams('No ticket was found with that ticket number.');
        }

        $statement = $this->database->prepare(
            'SELECT owner, message, created, type
             FROM messages WHERE ticket = :ticket_no
             ORDER BY created ASC, id ASC LIMIT 100'
        );
        $statement->execute(['ticket_no' => $ticket_no]);
        $ticket['conversation'] = $statement->fetchAll();

        return $ticket;
    }
}
