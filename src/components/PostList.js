import React,{useState} from "react";
import axios from "axios";
export default function PostList(postList) {
  
  //idk if this is how to get all posts
  // const[posts,getPosts] = useState('');
  
  // const url = 'http://localhost:80/api/postJob.php'

  const Post = (post) => {
  //   axios.get(url).then(response=>{
  //     const allPosts = response.data.JobPostTitle;
  //     getPosts(allPosts)
  //   }).catch(error=> console.log(`Error: ${error}`));
  //   console.log(posts,1)
    return <div>
      <p>Hello</p>
    </div>;
  };

  return (
    <div>
      <Post />
    </div>
  );
}
