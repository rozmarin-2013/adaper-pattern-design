<?php

interface SlugInterface
{
    public function generate(string $text): string;
}