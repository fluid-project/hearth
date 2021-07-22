require("./bootstrap");

import Alpine from 'alpinejs'

import confirmsPassword from './confirmsPassword.js';

Alpine.data('confirmsPassword', confirmsPassword)

Alpine.start();
