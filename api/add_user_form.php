<div class="user-form-container">
    <h2>New User</h2>
    <form id="new-user-form" onsubmit="submitNewUser(event)">
        
        <div style="display: flex; gap: 20px;">
            <div style="flex: 1;">
                <label for="firstname">First Name</label>
                <input type="text" id="firstname" name="firstname" placeholder="John" required>
            </div>
            <div style="flex: 1;">
                <label for="lastname">Last Name</label>
                <input type="text" id="lastname" name="lastname" placeholder="Doe" required>
            </div>
        </div>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="something@example.com" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <label for="role">Role</label>
        <select id="role" name="role">
            <option value="Member">Member</option>
            <option value="Admin">Admin</option>
        </select>

        <div style="text-align: right; margin-top: 20px;">
            <button type="submit" class="btn-primary">Save</button>
        </div>
    </form>
</div>