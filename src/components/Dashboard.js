import React from "react";
import "../styles/Dashboard.css";
import PostList from "./PostList";

export default function Dashboard() {
  return (
    <div className="split-pane-row">
      <div>
        <input
          className="Input-Field"
          placeholder="Search..."
          name="search"
          type="text"
        />
      </div>
      <div className="separator-row"></div>
      <div className="split-pane-col">
        <PostList />
      </div>
      <div className="separator-row"></div>

      <div className="split-pane-col">Select Job</div>
    </div>
  );
}
