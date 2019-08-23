import Plyr from 'plyr';

require('../css/app.scss');

const $ = require('jquery');
require('bootstrap');

$(document).ready(function () {
    $('[data-toggle="popover"]').popover();
    //const player = new Plyr('#player');
});