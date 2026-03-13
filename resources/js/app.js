import './bootstrap';
import Alpine from 'alpinejs';
import profileEditor from './components/profile-editor';
import crudUsers from './components/crud-users';

window.Alpine = Alpine;

Alpine.data('profileEditor', profileEditor);
Alpine.data('crudUsers', crudUsers);

Alpine.start();
