<?php

namespace SmileTrunk\Models;

interface UserInterface
{

    public function id();

    public function firstName();

    public function lastName();

    public function username();

    public function email();
}