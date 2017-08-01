<?php

namespace Ari\Api;

use Ari\Models\Mailbox;

/**
 * Mailboxes REST API
 */
class Mailboxes extends Api
{
    /**
     * List all mailboxes.
     *
     * @return Mailbox[]
     */
    public function getList()
    {
        $response = $this->request('GET', 'mailboxes');

        return $this->build($response, Mailbox::class);
    }

    /**
     * Retrieve the current state of a mailbox.
     *
     * @param string $mailboxName Name of the mailbox
     * @return Mailbox
     * @throws \Ari\Exception\NotFoundException
     */
    public function get($mailboxName)
    {
        $response = $this->request('GET', "mailboxes/$mailboxName");

        return $this->build($response, Mailbox::class);
    }

    /**
     * Change the state of a mailbox. (Note - implicitly creates the mailbox).
     *
     * @param string $mailboxName Name of the mailbox
     * @param array  $queryParams
     * @throws \Ari\Exception\NotFoundException
     */
    public function update($mailboxName, array $queryParams)
    {
        $params = array_merge([
            'newMessages' => null,
            'oldMessages' => null,
        ], $queryParams);

        $this->request('PUT', "mailboxes/$mailboxName", $params);
    }

    /**
     * Destroy a mailbox.
     *
     * @param string $mailboxName
     * @throws \Ari\Exception\NotFoundException
     */
    public function delete($mailboxName)
    {
        $this->request('DELETE', "mailboxes/$mailboxName");
    }
}
