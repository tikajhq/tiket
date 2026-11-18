<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/TicketRepository.php';
require_once __DIR__ . '/src/TicketTools.php';

use PhpMcp\Server\Server;
use PhpMcp\Server\Transports\StreamableHttpServerTransport;
use PhpMcp\Schema\ToolAnnotations;
use Tiket\Mcp\TicketRepository;
use Tiket\Mcp\TicketTools;

try {
    $tools = new TicketTools(TicketRepository::connect());
    $readOnly = ToolAnnotations::make(readOnlyHint: true, destructiveHint: false, openWorldHint: false);

    $server = Server::make()
        ->withServerInfo('Tiket Helpdesk', '1.0.0')
        ->withInstructions('This server provides read-only access to helpdesk tickets. It cannot create or change tickets.')
        ->withTool(
            function (string $search = '', int $limit = 20) use ($tools): array {
                return $tools->searchTickets($search, $limit);
            },
            name: 'search_tickets',
            description: 'Search ticket numbers or subjects and return up to 50 matching tickets.',
            annotations: $readOnly
        )
        ->withTool(
            function (string $ticket_no) use ($tools): array {
                return $tools->getTicket($ticket_no);
            },
            name: 'get_ticket',
            description: 'Read a ticket and its conversation using its full ticket number.',
            annotations: $readOnly
        )
        ->build();

    $server->listen(new StreamableHttpServerTransport('127.0.0.1', 8082, 'mcp'));
} catch (Throwable $exception) {
    fwrite(STDERR, 'Tiket MCP server failed: ' . $exception->getMessage() . PHP_EOL);
    exit(1);
}
