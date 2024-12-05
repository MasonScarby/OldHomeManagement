import './bootstrap';
import('../css/app.css');
import('../css/header.css');
import('../css/footer.css');

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
else if (document.body.classList.contains("patientList")) {
    import('../css/patientList.css');
}
else if (document.body.classList.contains("caregiverHome")) {
    import('../css/caregiverHome.css');
}
else if (document.body.classList.contains("approval")) {
    import('../css/approval.css');
}
else if (document.body.classList.contains("login")) {
    import('../css/login.css');
}
else if (document.body.classList.contains("register")) {
    import('../css/register.css');
}
else if (document.body.classList.contains("newRoster")) {
    import('../css/newRoster.css');
}
else if (document.body.classList.contains("rosterList")) {
    import('../css/rosterList.css');
}

