import React, { ReactElement, useState } from 'react';
import { Button } from '@material-tailwind/react';
import ContactForm from '@components/ContactForm';

const Home = (): ReactElement => {
  const [isOpen, setIsOpen] = useState(false);

  const handleContactUs = () => {
    window.location.hash = '#start';
    setIsOpen(true);
  };

  return (
    <div className="container mx-auto px-4">
      <Button onClick={handleContactUs}>Contact Us</Button>

      <ContactForm isOpen={isOpen} onClose={() => setIsOpen(false)} />
    </div>
  );
};

export default Home;
