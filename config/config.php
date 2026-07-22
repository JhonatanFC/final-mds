<?php

declare(strict_types=1);

date_default_timezone_set('America/Lima');

const APP_NAME = 'RMRS';
const APP_ENV = 'development';
const APP_DEBUG = false;

const APP_URL = 'http://localhost/restaurant-system/public';
const BASE_PATH = __DIR__ . '/..';

const RESERVATION_ADVANCE = 30.00;
const RESERVATION_TOLERANCE_MINUTES = 20;
const RESERVATION_DURATION_MINUTES = 120;