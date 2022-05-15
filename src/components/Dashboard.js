import React from "react";
import { useSelector } from "react-redux";
import { Link } from "react-router-dom";
import "../styles/Dashboard.css";
import PostList from "./PostList";

export default function Dashboard() {
  const isAuth = useSelector((state) => state.user.isAuthed);
  const name = useSelector((state) => state.user.firstName);

  return (
    <div className="split-pane-row">
      <div>
        <h1 className="cloudHeader">CloudJobs</h1>
        <input
          className="Input-Field"
          placeholder="Search..."
          name="search"
          type="text"
        />
        <h3>Filter By Employer</h3>
        {isAuth ? (
          <div>
            <span>Welcome Back, {name}</span>
          </div>
        ) : (
          <div>
            <Link to="/signin">
              <button className="signup-btn">
                <span className="signup-text">Login</span>
              </button>
            </Link>
            <button className="login-btn">
              <span className="login-text">Sign Up</span>
            </button>
          </div>
        )}
      </div>
      <div className="separator-row"></div>
      <div className="split-pane-col">
        <div className="post-container">
          <div className="post-container2">
            <PostList />
          </div>
        </div>
      </div>
      <div className="separator-row"></div>

      <div className="split-pane-col">Select Job</div>
    </div>
  );
}
