import './bootstrap';

if (document.body.classList.contains("createAppointments")) {
    import('../css/createAppointment.css');
}
else if (document.body.classList.contains("roles")) {
    import('../css/roles.css');

}
else if (document.body.classList.contains("employees")) {
    import('../css/employees.css');
}