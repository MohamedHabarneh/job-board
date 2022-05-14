import React from "react";
import "../styles/Dashboard.css";
import PostList from "./PostList";

export default function Dashboard() {
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

        <button className="login-btn"><span className="login-text">Login</span></button>
        <button className="signup-btn"><span className="signup-text">Sign up</span></button>
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
