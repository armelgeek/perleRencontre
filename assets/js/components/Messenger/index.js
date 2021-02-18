
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
    let {id} = props
    console.log(id)
    useEffect(() => {
      getOnlineUsers();
      getConversations();
    },[])

 

    let loadData = async (conversation)=> {
      axios.get('/chat/api/messages/'+conversation.id).then(response =>{
        setMessages(<MessageList  loading={isLoading} userId={id} conversation={conversation} messages={response.data} />);
      })
    }

    let getOnlineUsers = async ()=> {
      axios.get('/chat/api/list_connections').then(response =>{
        setOnlineUsers([...onlineUsers,...response.data])
      })
    }


     const getConversations = () => {
     var defaultValue = 1 ;
      axios.get('/chat/api/conversations/'+defaultValue).then(response => {
          
          setConversations([...conversations,...response.data])
          // loadData(response.data[0])
          if(response.data.length > 0){
              let conversation = response.data[0]
              console.log(conversation);
              setMessages(<MessageList  loading={isLoading} conversation={conversation} messages={conversation.messages} userId={id}/>);
          }
          
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
                  userId={id}
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