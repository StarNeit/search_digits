import {
  Card,
  CardHeader,
  CardFooter,
  Progress,
  Button
} from '@material-tailwind/react';
import LargeIcon1Image from '@assets/images/large-icon-1.avif';
import LargeIcon2Image from '@assets/images/large-icon-2.avif';

const LABELS = [
  'Only three questions',
  '100% free of charge',
  'individual consultation'
];

const Start = () => {
  const handleSelect = () => {
    window.location.hash = '#question-2';
  };

  return (
    <div>
      <h1 className="text-2xl md:text-3xl text-black font-semibold mb-6 md:mb-10">
        Get a free <span className="text-red-500">Pest Control Quote</span> from
        your Local Trusted Experts
      </h1>

      <div className="flex gap-4 md:gap-8 flex-col md:flex-row">
        <div className="flex-1">
          <Progress value={33} size="sm" color="red" />
          <div className="px-0 md:px-4 pt-4 md:pt-8">
            <p className="text-sm text-red-800 mb-1 md:mb-4 font-semibold">
              Question 1 of 3
            </p>
            <h2 className="text-base md:text-lg font-semibold text-black">
              Is this an emergency? Do you need same-day service?
            </h2>
          </div>
        </div>
        <div className="flex gap-4">
          <Card className="w-40 p-0 shadow-none border border-gray-200">
            <CardHeader shadow={false} floated={false} className="h-40 p-0 m-0">
              <img
                src={LargeIcon1Image}
                alt="card-image"
                className="h-full w-full object-cover"
              />
            </CardHeader>
            <CardFooter className="pt-6 p-3">
              <Button
                ripple={false}
                fullWidth={true}
                className="bg-blue-gray-900/10 text-blue-gray-900 shadow-none hover:scale-105 hover:shadow-none focus:scale-105 focus:shadow-none active:scale-100"
                onClick={handleSelect}>
                Yes
              </Button>
            </CardFooter>
          </Card>
          <Card className="w-40 p-0 shadow-none border border-gray-200">
            <CardHeader shadow={false} floated={false} className="h-40 p-0 m-0">
              <img
                src={LargeIcon2Image}
                alt="card-image"
                className="h-full w-full object-cover"
              />
            </CardHeader>
            <CardFooter className="pt-6 p-3">
              <Button
                ripple={false}
                fullWidth={true}
                className="bg-blue-gray-900/10 text-blue-gray-900 shadow-none hover:scale-105 hover:shadow-none focus:scale-105 focus:shadow-none active:scale-100"
                onClick={handleSelect}>
                No
              </Button>
            </CardFooter>
          </Card>
        </div>
      </div>

      <div className="flex flex-col lg:flex-row justify-between gap-3 border-t border-t-gray-200 pt-6 mt-6 md:mt-10">
        {LABELS.map((item, index) => (
          <div key={index} className="flex gap-2 items-center">
            <svg
              className="w-4 h-4 text-red-800"
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 24 24">
              <path d="M0 0h24v24H0z" fill="none"></path>
              <path
                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"
                fill="currentColor"></path>
            </svg>
            <span className="text-black text-sm md:text-base">{item}</span>
          </div>
        ))}
      </div>
    </div>
  );
};

export default Start;
