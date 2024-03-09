<template>
    <header>
        <span class="header-text">Create New User</span>
    </header>
    <div class="form-container">
        <form class="form">
            <div class="row">
                <div class="col-4">
                    <div class="mb-3">
                        <label for="first-name" class="form-label">First Name</label>
                        <input id="first-name" class="form-control" type="text" placeholder="John" aria-label="First Name">
                    </div>
                </div>
                <div class="col-4">
                    <div class="mb-3">
                        <label for="last-name" class="form-label">Last Name</label>
                        <input id="last-name" class="form-control" type="text" placeholder="Doe" aria-label="Last Name">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="mb-3">
                        <label for="email-address" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email-address" placeholder="name@example.com" aria-label="Email">
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label for="email-address" class="form-label">Password</label>
                        <input type="email" class="form-control" id="email-address" placeholder="name@example.com" aria-label="Email">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select id="role" class="form-select" aria-label="Role">
                            <option value="1">Moderator</option>
                            <option value="2">SME</option>
                            <option value="3">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="col-4">
                    <button class="btn btn-primary" style="margin-top: 30px;">Create</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    name: "Create",
    methods: {
        getRoles: function () {
            //axios.get(route('admin.'))
        },
        generatedPassword () {
            let charactersArray = 'a-z'.split(',')
            let CharacterSet = ''
            let password = ''
            let size = 8

            charactersArray = 'a-z,A-Z,0-9,#'.split(',')

            if (charactersArray.indexOf('a-z') >= 0) {
                CharacterSet += 'abcdefghijklmnopqrstuvwxyz'
            }
            if (charactersArray.indexOf('A-Z') >= 0) {
                CharacterSet += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
            }

            if (charactersArray.indexOf('0-9') >= 0) {
                CharacterSet += '0123456789'
            }
            if (charactersArray.indexOf('#') >= 0) {
                CharacterSet += '![]{}()%&*$#^<>~@|'
            }
            for (let i = 0; i < size; i++) {
                password += CharacterSet.charAt(Math.floor(Math.random() * CharacterSet.length))
            }

            return password
        },
    }
}
</script>

<style scoped>

</style>
