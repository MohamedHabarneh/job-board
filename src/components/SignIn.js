import React from "react";
import { Link } from "react-router-dom";

import "../styles/SignIn.css";

export default function SignIn() {
  return (
    <div className="Comp-Wrapper">
      <img src={window.location.origin + "/login_img.png"} alt="Job Search" />

      <div className="Form-Wrapper">
        <form>
          <h2>Welcome Back to Cloud Jobs</h2>
          <Link className="New-Text" to="user/create">
            New to Cloud Jobs? Click here!
          </Link>
          <p>
            <input className="Input-Field" placeholder="Username" type="text" />
          </p>
          <input
            className="Input-Field"
            placeholder="Password"
            type="password"
          />
          <div>
            <button type="submit">Submit</button>
          </div>
        </form>
      </div>
    </div>
  );
}
