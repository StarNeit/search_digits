import React, { useEffect, useState } from 'react';
import { Dialog, DialogBody } from '@material-tailwind/react';
import Start from '@components/ContactForm/Start';
import TypeOfProperty from '@components/ContactForm/TypeOfProperty';
import Weather from '@components/ContactForm/Weather';
import FinalStep from '@components/ContactForm/FinalStep';
import { AnimatePresence } from 'motion/react';
import { useLocation } from 'react-router-dom';
import FadeIn from '@components/FadeIn';

type Props = {
  isOpen: boolean;
  onClose: () => void;
};

const ContactForm: React.FC<Props> = ({ isOpen, onClose }) => {
  const location = useLocation();
  const [value, setValue] = useState('#start');

  useEffect(() => {
    setValue(location.hash);
  }, [location.hash]);

  return (
    <Dialog open={isOpen} handler={onClose} size="lg">
      <DialogBody className="px-4 md:px-8 py-6 md:py-10 overflow-hidden">
        <AnimatePresence mode="wait">
          {value === '#start' && (
            <FadeIn frameKey="#start">
              <Start />
            </FadeIn>
          )}
          {value === '#question-2' && (
            <FadeIn frameKey="#question-2">
              <TypeOfProperty />
            </FadeIn>
          )}
          {value === '#question-4' && (
            <FadeIn frameKey="#question-4">
              <Weather />
            </FadeIn>
          )}
          {value === '#details-form-02' && (
            <FadeIn frameKey="#details-form-02">
              <FinalStep onCloseModal={onClose} />
            </FadeIn>
          )}
        </AnimatePresence>
      </DialogBody>
    </Dialog>
  );
};

export default ContactForm;
