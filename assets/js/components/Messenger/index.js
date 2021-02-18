
import React,{useState,useEffect} from 'react';
import MessageList from '../MessageList';
import ConversationSearch from '../ConversationSearch';
import Connected from '../Connected';
import ConversationListItem from '../ConversationListItem';
import Toolbar from '../Toolbar';
import ToolbarButton from '../ToolbarButton';
import axios from 'axios';
import './Messenger.css';

export default function Messenger(props) {
    let [room,setRoom] = useState();
    let [messages,setMessages] = useState();
    const [conversations, setConversations] = useState([]);
    let [onlineUsers,setOnlineUsers] = useState([])
    let [isLoading,setIsLoading] = useState(false);

    let [userId,setUserId] = useState(0)

    useEffect(() => {
      getOnlineUsers();
      getConversations();
    },[])

 

    let loadData = async (conversation)=> {
      // console.log(conversation.messages);
      axios.get('/chat/api/messages/'+conversation.id).then(response =>{
        setMessages(<MessageList current={conversation.uti} loading={isLoading} conversation={conversation} messages={response.data} />);
      })
    }

    let getOnlineUsers = async ()=> {
      axios.get('/chat/api/list_connections').then(response =>{
        setOnlineUsers([...onlineUsers,...response.data])
      })
    }
     const getConversations = () => {
     var defaultValue = 0 ;
      var userElement = document.getElementById("user_id")
      if(userElement != undefined){
        defaultValue = userElement.value;
        setUserId(defaultValue);
      }
      axios.get('/chat/api/conversations/'+defaultValue).then(response => {
          console.log(response.data);
          setConversations([...conversations,...response.data])
          // loadData(response.data[0])
      });
    }

    return (
      <div className="messenger">
        <div className="scrollable sidebar">
          {/* Conversation list */}
          <div className="conversation-list">
            <Toolbar className="fixed"
              title="Chat"
              leftItems={[
                <ToolbarButton key="cog" icon="ion-ios-cog" />
              ]}
              rightItems={[
                <ToolbarButton key="add" icon="ion-ios-add-circle-outline" />
              ]}
            />
            <Connected users={onlineUsers}  handleData={loadData} />
            <ConversationSearch />
            {
              conversations.map((conversation,index) =>{
                return <ConversationListItem handleData={loadData}
                  key={index}
                  data={conversation}
                  userId={userId}
                />}
              )
            }
          </div>
        </div>
        {/* Message */}
        <div className="scrollable content">
          {messages}
        </div>
      </div>
    );
}