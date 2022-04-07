export default class Gate {

    constructor(user) {
        this.user = user;
    }

    isAdmin() {
        return this.user.roles.find(role => role.name === 'Администратор');
    }

    isUser() {
        return this.user.roles.find(role => role.name === 'Пользователь');
    }

    isTeacher() {
        return this.user.roles.find(role => role.name === 'Преподаватель');
    }

    isAdminOrUser() {
        if (this.user.type === 'user' || this.user.type === 'admin') {
            return true;
        }
    }
}