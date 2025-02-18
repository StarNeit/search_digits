import {
  Card,
  CardFooter,
  CardHeader,
  Progress
} from '@material-tailwind/react';
import MorningIcon from '@assets/images/morning-icon.svg';
import NoonIcon from '@assets/images/noon-icon.svg';
import EveningIcon from '@assets/images/evening-icon.svg';
import SunGlassIcon from '@assets/images/sunglass-icon.svg';
import { useOnBoardingStore } from '@stores';
import { TimeType } from '@types';

const OPTIONS = [
  {
    label: 'In the morning',
    value: TimeType.MORNING,
    icon: MorningIcon
  },
  {
    label: 'In the afternoon',
    value: TimeType.AFTERNOON,
    icon: NoonIcon
  },
  {
    label: 'In evening',
    value: TimeType.EVENING,
    icon: EveningIcon
  },
  {
    label: 'Anytime',
    value: TimeType.ANYTIME,
    icon: SunGlassIcon
  }
];

const Weather = () => {
  const { setTime } = useOnBoardingStore();

  const handleSelectWeather = (value: TimeType) => {
    setTime(value);
    window.location.hash = '#details-form-02';
  };

  return (
    <div>
      <Progress value={100} size="sm" color="red" />
      <div className="pt-4 md:pt-8">
        <p className="text-sm text-red-800 mb-1 md:mb-4 font-semibold">
          Almost done!
        </p>
        <h2 className="text-base md:text-lg font-semibold text-black">
          When would you prefer a callback?
        </h2>
      </div>

      <div className="grid grid-cols-2 lg:grid-cols-4 gap-4 pt-6 max-h-[60vh] overflow-auto">
        {OPTIONS.map((opt, index) => (
          <Card
            key={index}
            onClick={() => handleSelectWeather(opt.value)}
            className="w-full p-0 shadow-none border border-gray-200 cursor-pointer hover:shadow">
            <CardHeader
              shadow={false}
              floated={false}
              className="h-32 md:h-40 p-0 m-0 flex items-center justify-center bg-gray-100">
              <img src={opt.icon} alt="weather-icon" />
            </CardHeader>
            <CardFooter className="pt-6 px-0 md:px-1 text-black text-center text-sm md:text-base font-semibold md:font-bold">
              {opt.label}
            </CardFooter>
          </Card>
        ))}
      </div>
    </div>
  );
};

export default Weather;
