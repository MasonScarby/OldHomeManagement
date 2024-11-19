import './bootstrap';

if (document.body.classList.contains("createAppointment")) {
    import('../css/createAppointment.css');
}
else if (document.body.classList.contains("roles")) {
    import('../css/roles.css');
}
else if (document.body.classList.contains("employees")) {
    import('../css/employees.css');
}
else if (document.body.classList.contains("patientAssignment")) {
    import('../css/patientAssignment.css');
}
