<?php


namespace App\Helpers;


use GuzzleHttp\Client;
use Illuminate\Support\Collection;

class JavaInstaller
{
    protected static $BASE_URI = 'https://api.adoptopenjdk.net/v2/info/releases';

    protected static $AVAILABLE_OS = [
        ['name' => 'MacOS', 'value' => 'mac'],
        ['name' => 'Linux', 'value' => 'linux'],
        ['name' => 'Window', 'value' => 'windows'],
    ];

    protected static $ARCHS = [
        'x64', 'x32'
    ];

    protected static $JDK_VERSIONS = [
        'openjdk13', 'openjdk11', 'openjdk8'
    ];

    public function getOSNames():array
    {
        return array_map(function ($os) {
            return $os['name'];
        }, static::$AVAILABLE_OS);
    }

    public function getOSValue(int $index):string
    {
        return static::$AVAILABLE_OS[$index]['value'];
    }

    public function getArchs():array
    {
        return static::$ARCHS;
    }

    public function getJDKVersions():array
    {
        return static::$JDK_VERSIONS;
    }

    public function getJDks(int $jdkVersion, int $os, int $arch):Collection
    {
        $client = new Client();

        $response = $client->get(static::$BASE_URI . '/' . $this->getJDKVersions()[$jdkVersion], [
           'query' => [
               'openjdk_impl' => 'hotspot',
               'type' => 'jdk',
               'os' => $this->getOSValue($os),
               'arch' => $this->getArchs()[0]
           ]
        ]);

        return collect(json_decode($response->getBody()->getContents(), true))->reverse();
    }
}
