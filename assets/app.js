/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';
import './styles/quill.snow.css';
import Quill from './vendor/quill/quill.index.js';
window.Quill = Quill;
