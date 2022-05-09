import {
    createSlice
} from '@reduxjs/toolkit'

const initialState = {
    userID: null,
    firstName: null,
    lastName: null,
    isAuthed: false,
    isEmployer: false,
    email: null,
    employerID: null,
    addressID: null,
    savedPosts: [],
    appliedPosts: [],
    postedPosts: [],
    hiringRoleID: null,
    educationLevel: null,
}

export const userSlice = createSlice({
    name: 'user',
    initialState,
    reducers: {
        setAuth: (state, action) => {
            state.isAuthed = action.payload
        },
        setEmployer: (state, action) => {
            state.isEmployer = true
            state.employerID = action.payload.employerID
            state.addressID = action.payload.addressID
            state.hiringRoleID = action.payload.hiringRoleID

        },
        removeUser: (state) => {
            state = initialState
            state.isAuthed = false

        },
        setUser(state, action) {
            state.userID = action.payload.userID
            state.firstName = action.payload.firstName
            state.lastName = action.payload.lastName
            state.email = action.payload.email
        }
    },
})

// Action creators are generated for each case reducer function
export const {
    setAuth,
    decrement,
    incrementByAmount
} = userSlice.actions

export default userSlice.reducer