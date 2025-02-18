import { Route, BrowserRouter as Router, Routes } from 'react-router-dom';
import Home from '@pages/Home';

function App() {
  return (
    <>
      <Router>
        <div className="py-5 sm:py-10">
          <Routes>
            <Route path="/" element={<Home />} />
          </Routes>
        </div>
      </Router>
    </>
  );
}

export default App;
