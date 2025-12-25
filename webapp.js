document.addEventListener('DOMContentLoaded', function() {
    // Load dashboard by default on first visit
    loadPage('dashboard');
});

/**
 * Handles SPA navigation by fetching content and updating sidebar states
 */
function loadPage(page) {
    const main = document.getElementById('result');
    const navButtons = document.querySelectorAll('.nav-btn');
    
    // 1. Update visual 'active' state on sidebar buttons
    navButtons.forEach(btn => {
        btn.classList.remove('active');
        // Match button based on the page string passed to loadPage
        if (btn.getAttribute('onclick').includes(`'${page}'`)) {
            btn.classList.add('active');
        }
    });

    // 2. Content Routing Logic
    if (page === 'dashboard') {
        fetch('api/dashboard.php?filter=all')
            .then(response => response.text())
            .then(data => { main.innerHTML = data; })
            .catch(err => console.error('Dashboard error:', err));
            
    } else if (page === 'new_contact') {
        fetch('newcontact.php')
            .then(response => response.text())
            .then(html => { main.innerHTML = html; })
            .catch(err => console.error('New Contact error:', err));

    } else if (page === 'users') {
        fetch('api/users.php')
            .then(response => response.text())
            .then(html => { main.innerHTML = html; })
            .catch(err => console.error('User list error:', err));
            
    } else if (page === 'add_user') {
        fetch('api/add_user_form.php')
            .then(response => response.text())
            .then(html => { main.innerHTML = html; })
            .catch(err => console.error('Add user form error:', err));
    }
}

/**
 * Filters the dashboard table without refreshing the page
 */
function filterContacts(filterType) {
    fetch(`api/dashboard.php?filter=${filterType}`)
    .then(response => response.text())
    .then(data => {
        document.getElementById('result').innerHTML = data;
        
        // Update active state on filter buttons
        document.querySelectorAll('.filters button').forEach(btn => {
            btn.classList.remove('active');
            if (btn.getAttribute('onclick').includes(`'${filterType}'`)) {
                btn.classList.add('active');
            }
        });
    });
}

/**
 * Submits the new contact form via AJAX
 */
function submitNewContact(event) {
    event.preventDefault();
    const formData = new FormData(event.target);

    fetch('api/add_contact.php', { method: 'POST', body: formData })
    .then(response => response.text())
    .then(data => {
        if(data.trim() === 'success') {
            alert("Contact Added Successfully"); 
            loadPage('dashboard');
        } else {
            alert("Error adding contact: " + data);
        }
    })
    .catch(err => console.error('Submission error:', err));
}

/**
 * Loads individual contact details page
 */
function viewContact(contactId) {
    fetch(`api/contact_details.php?id=${contactId}`)
    .then(response => response.text())
    .then(data => {
        document.getElementById('result').innerHTML = data;
    })
    .catch(err => console.error('Contact details error:', err));
}

/**
 * Adds a note to a contact
 */
function addNote(event, contactId) {
    event.preventDefault();
    const formData = new FormData(event.target);
    formData.append('contact_id', contactId);

    fetch('api/add_note.php', { method: 'POST', body: formData })
    .then(response => response.text())
    .then(data => {
        if(data.trim() === 'success') {
            viewContact(contactId); // Reload contact details
        } else {
            alert("Error adding note: " + data);
        }
    })
    .catch(err => console.error('Add note error:', err));
}

/**
 * Assigns contact to current user
 */
function assignToMe(contactId) {
    fetch('api/assign_contact.php', { 
        method: 'POST', 
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `contact_id=${contactId}`
    })
    .then(response => response.text())
    .then(data => {
        if(data.trim() === 'success') {
            viewContact(contactId); // Reload to show updated assignment
        } else {
            alert("Error assigning contact");
        }
    });
}

/**
 * Switches contact type between Sales Lead and Support
 */
function switchType(contactId) {
    fetch('api/switch_type.php', { 
        method: 'POST', 
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `contact_id=${contactId}`
    })
    .then(response => response.text())
    .then(data => {
        if(data.trim() === 'success') {
            viewContact(contactId); // Reload to show updated type
        } else {
            alert("Error switching type");
        }
    });
}

/**
 * Submits the new user form via AJAX
 */
function submitNewUser(event) {
    event.preventDefault();
    const formData = new FormData(event.target);

    fetch('api/add_user.php', { method: 'POST', body: formData })
    .then(response => response.text())
    .then(data => {
        if(data.trim() === 'success') {
            alert("User Added Successfully"); 
            loadPage('users');
        } else {
            alert("Error adding user: " + data);
        }
    })
    .catch(err => console.error('User submission error:', err));
}