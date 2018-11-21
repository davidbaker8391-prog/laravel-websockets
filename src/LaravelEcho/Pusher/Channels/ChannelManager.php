<?php

namespace BeyondCode\LaravelWebSockets\LaravelEcho\Pusher\Channels;


class ChannelManager
{
    protected $channels = [];

    public function findOrCreate(string $channelId)
    {
        if (! isset($this->channels[$channelId])) {
            $channelClass = $this->detectChannelClass($channelId);
            $this->channels[$channelId] = new $channelClass($channelId);
        }

        return $this->channels[$channelId];
    }

    protected function detectChannelClass($channelId) : string
    {
        if (starts_with($channelId, 'private-')) {
            return PrivateChannel::class;
        } elseif(starts_with($channelId, 'presence-')) {
            return PresenceChannel::class;
        }
        return Channel::class;
    }
}