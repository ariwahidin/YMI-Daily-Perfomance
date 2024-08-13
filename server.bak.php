<?php
// Include library Ratchet
require 'vendor\autoload.php';


use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\WebSocket\WsServer;
use Ratchet\Http\HttpServer;
use Ratchet\Http\HttpServerInterface;
use Ratchet\Server\IoServer;

// Definisikan kelas Chat
class KitchenChat implements MessageComponentInterface
{
    protected $clients;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        // Tambahkan koneksi klien ke daftar koneksi yang aktif
        $this->clients->attach($conn);
        echo "Klien terhubung ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        // Kirim pesan ke klien yang sesuai
        foreach ($this->clients as $client) {
            if ($from !== $client) {
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        // Hapus koneksi klien dari daftar koneksi yang aktif
        $this->clients->detach($conn);
        echo "Klien terputus ({$conn->resourceId})\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "Kesalahan: {$e->getMessage()}\n";
        $conn->close();
    }
}

// Jalankan server WebSocket dengan HTTP
$port = 8001;
$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new KitchenChat()
        )
    ),
    $port // Port yang ingin Anda gunakan
);

echo "Server WebSocket berjalan di port " . $port . " ...\n";

$server->run();
