<?php

function isPath(string $route): bool
{
    $requestedPath = strtok($_SERVER["REQUEST_URI"], '?');

    $pathSeparatorPattern = "#/#";

    $routeParts = preg_split($pathSeparatorPattern, trim($route, "/"));
    $pathParts = preg_split($pathSeparatorPattern, trim($requestedPath, "/"));

    if (count($routeParts) !== count($pathParts)) {
        return false;
    }

    foreach ($routeParts as $routePartIndex => $routePart) {
        $pathPart = $pathParts[$routePartIndex];

        if (str_starts_with($routePart, ":")) {
            continue;
        }

        if ($routePart !== $pathPart) {
            return false;
        }
    }

    return true;
}