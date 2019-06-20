export default class Gate{
    constructor(user){
        this.user=user;
    }
    isAdmin(){
        return this.user.role === 1;
    }

    isUser(){
        return this.user.role === 2;
    }
}