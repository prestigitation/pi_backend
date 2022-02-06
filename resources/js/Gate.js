export default class Gate {

    constructor(user) {
        this.user = user;
    }

    isAdmin() {
        return this.user.roles[0].name === 'Администратор';
    }

    isUser() {
        return this.user.roles[0].name === 'Пользователь';
    }

    isAdminOrUser() {
        if (this.user.type === 'user' || this.user.type === 'admin') {
            return true;
        }
    }
}