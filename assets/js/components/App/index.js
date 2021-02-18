import React,{ useState, useEffect } from 'react';
import Messenger from '../Messenger';
import socketIOClient from "socket.io-client";
import './App.css';

const ENDPOINT = "http://localhost:3001";


export default function App() {

  const[messenger,setMessengers] = useState()
  const [userId,setUserId] = useState(0);

    useEffect(() => {
      var userElement = document.getElementById("user_id");
      if(userElement != undefined){
          setUserId(userElement.value);
          setMessengers(<Messenger id={userElement.value}/>)
      }
    }, []);

    return (
      <div className="App">
        {messenger}
      </div>
    );
}