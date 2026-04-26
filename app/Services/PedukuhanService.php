<?php

namespace App\Services;

use App\Models\Pedukuhan;

class PedukuhanService
{
    /**
     * Create a new pedukuhan.
     *
     * @param array $data
     * @return Pedukuhan
     */
    public function createPedukuhan(array $data): Pedukuhan
    {
        return Pedukuhan::create($data);
    }

    /**
     * Update an existing pedukuhan.
     *
     * @param Pedukuhan $pedukuhan
     * @param array $data
     * @return Pedukuhan
     */
    public function updatePedukuhan(Pedukuhan $pedukuhan, array $data): Pedukuhan
    {
        $pedukuhan->update($data);
        return $pedukuhan;
    }

    /**
     * Delete a pedukuhan.
     *
     * @param Pedukuhan $pedukuhan
     * @return void
     */
    public function deletePedukuhan(Pedukuhan $pedukuhan): void
    {
        $pedukuhan->delete();
    }
}
