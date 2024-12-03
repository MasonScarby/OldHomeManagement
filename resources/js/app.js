import './bootstrap';
import('../css/app.css');
import('../css/header.css');

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

