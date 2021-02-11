import React,{ useState, useEffect } from 'react';
import Messenger from '../Messenger';
import socketIOClient from "socket.io-client";

const ENDPOINT = "http://localhost:3001";


export default function App() {

  const[messenger,setMessengers] = useState( <Messenger />)

    useEffect(() => {
      const socket = socketIOClient(ENDPOINT);
      socket.on("FromAPI", data => {
      });
      socket.on('connect',()=>{
        console.log("Connected")
      });
    }, []);

    return (
      <div className="App">
        {messenger}
      </div>
    );
}