import React, { useState } from "react";
import { Link } from "react-router-dom";

import "../styles/SignIn.css";
import axios from "axios";
import { useNavigate } from "react-router-dom";
import { useDispatch } from "react-redux";
import { setJWT } from "../features/userSlice";

export default function SignIn() {
  const dispatch = useDispatch();

  const config = {
    headers: {
      "Content-Type": "application/json",
      "Access-Control-Allow-Origin": "*",
    },
  };
  const navigate = useNavigate();
  const [loginInfo, setLoginInfo] = useState({
    username: "",
    pass: "",
  });
  const handleChange = (e) => {
    const name = e.target.name;
    const value = e.target.value;
    setLoginInfo({ ...loginInfo, [name]: value });
  };
  const handleSubmit = (event) => {
    event.preventDefault();

    //reset all inputs
    const eInputs = document.querySelector("input");
    for (let i = 0; i < eInputs.length; i++) {
      eInputs[i].value = "";
    }
    axios
      .post("http://localhost/api/login.php", loginInfo, config)
      .then(function (response) {
        dispatch(setJWT(response.data.jwt));
        navigate("/");
      });
  };

  return (
    <div className="Comp-Wrapper">
      <img src={window.location.origin + "/login_img.png"} alt="Job Search" />

      <div className="Form-Wrapper">
        <form onSubmit={handleSubmit}>
          <h2>Welcome Back to Cloud Jobs</h2>
          <Link className="New-Text" to="user/create">
            New to Cloud Jobs? Click here!
          </Link>
          <p>
            <input
              className="Input-Field"
              placeholder="Account Email"
              name="email"
              onChange={handleChange}
              type="text"
              required
            />
          </p>
          <input
            className="Input-Field"
            placeholder="Password"
            name="password"
            onChange={handleChange}
            type="password"
            required
          />
          <div>
            <button type="submit">Submit</button>
          </div>
        </form>
      </div>
    </div>
  );
}
