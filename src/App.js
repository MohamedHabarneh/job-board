import axios from "axios";
import { useEffect } from "react";
import { useDispatch, useSelector } from "react-redux";
import { BrowserRouter, Routes, Route, Link, Navigate } from "react-router-dom";
import "./App.css";
import CreateUser from "./components/CreateUser";
import Dashboard from "./components/Dashboard";
import EditUser from "./components/EditUser";
import EmployerForm from "./components/EmployerForm";
import MyJobs from "./components/MyJobs";

import SignIn from "./components/SignIn";
import { setUser } from "./features/userSlice";

function App() {
  const token = useSelector((state) => state.user.jwt);
  const isAuth = useSelector((state) => state.user.isAuth);
  const dispatch = useDispatch();

  useEffect(() => {
    const config = {
      headers: {
        "Content-Type": "application/json",
        "Access-Control-Allow-Origin": "*",
      },
    };
    if (token === null) {
      console.log("empty token");
    }
    axios
      .post("http://localhost/api/validateToken.php", { jwt: token }, config)
      .then(function (response) {
        const data = response.data.data;
        console.log(data);
        if (response.status === 200) {
          dispatch(
            setUser({
              userID: data.id,
              firstName: data.fName,
              lastName: data.lName,
              email: data.email,
            })
          );
        }
      });
  }, [dispatch, token]);

  return (
    <div className="App">
      <BrowserRouter>
        <div className="App-header">
          <Link to="/">
            <img
              className="Logo"
              src={
                window.location.origin +
                "/logo/Cloud-Jobs-logos_transparent.png"
              }
              alt="App-Logo"
            />
          </Link>
          <nav>
            <ul>
              <li>
                <Link to="/">Home</Link>
              </li>
              <li>
                <Link to="/myjobs">My Jobs</Link>
              </li>
            </ul>
          </nav>
        </div>
        <Routes>
          <Route
            path="signin"
            element={isAuth ? <Navigate to="/" /> : <SignIn />}
          />
          <Route index element={<Dashboard />} />
          <Route path="user/create" element={<CreateUser />} />
          <Route path="myjobs" element={<MyJobs />} />
          <Route path="user/:id/edit" element={<EditUser />} />
          <Route path="user/employerForm" element={<EmployerForm />} />
        </Routes>
      </BrowserRouter>
    </div>
  );
}
export default App;
